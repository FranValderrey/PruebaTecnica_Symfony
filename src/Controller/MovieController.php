<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class MovieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/movies', name: 'post_movie', methods: ['POST'])]
    public function createMovie(Request $request): JsonResponse
    {
        // Obtener datos del cuerpo de la solicitud
        $requestData = json_decode($request->getContent(), true);

        // Obtener el ID de la película de TheMovieDB
        $movieId = $requestData['moviedb_id'];

        // Hacer la solicitud a la API de TheMovieDB
        $apiKey = '152718166a0c49e6dcceb43f7d5bfc21';
        $url = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}&language=en-US";

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);

        // Obtener los detalles de la película
        $movieDetails = $response->toArray();

        // Guardar los datos en la base de datos (usando Doctrine ORM)
        $movie = new Movie();
        $movie->setName($requestData['name']);
        $movie->setFullDetails($movieDetails);

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Movie created successfully'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/movies', name: 'list_movies', methods: ['GET'])]
    public function listMovies(EntityManagerInterface $entityManager): JsonResponse
    {
        // Obtener la lista de películas desde tu base de datos
        $movies = $entityManager->getRepository(Movie::class)->findAll();

        // Transformar la lista de películas en un formato adecuado para JSON
        $formattedMovies = [];
        foreach ($movies as $movie) {
            $formattedMovies[] = [
                'id' => $movie->getId(),
                'name' => $movie->getName(),
                'full_details' => $movie->getFullDetails(),
            ];
        }

        // Devolver una respuesta JSON con la lista de películas
        return $this->json($formattedMovies, JsonResponse::HTTP_OK);
    }
}
