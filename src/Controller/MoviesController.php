<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movies;

/**
 * @Route("/movies")
 */
class MoviesController extends AbstractController
{
    /**
     * @Route("/", name="movies")
     */
    public function movies(Request $request)
    {
        $orderBy = (string) $request->query->get('orderBy', 'date');
        $asc = (bool) $request->query->get('asc', false);
        $limit = (int) $request->query->get('limit', 100);
        $offset = (int) $request->query->get('offset', 0);
        if ($limit > 100) {
            throw new HttpException(406, "Limit is maximum 100");
        }

        try {
            $movies = $this->getDoctrine()
            ->getRepository(Movies::class)
            ->findBy([], [$orderBy => $asc ? 'ASC' : 'DESC'], $limit);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage(), $e);
        }

        $response = [];

        foreach ($movies as $movie) {
            $author = $movie->getAuthor();
            $response[] = [
                'id' => $movie->getId(),
                'name' => $movie->getName(),
                'reviews' => $movie->getReviews(),
                'author' => [
                    'id' => $author->getId(),
                    'name' => $author->getName(),
                ]
            ];
        }

        return new JsonResponse($response);
    }
}
