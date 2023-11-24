<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Collections\ArticleCollection;
use App\Models\Article;
use App\ViewResponse;
use App\RedirectResponse;
use App\Response;
use Carbon\Carbon;

class ArticleController extends BaseController
{
    public function index(): Response
    {
        $articles = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articlesCollection = new ArticleCollection();

        foreach ($articles as $article)
        {
            $articlesCollection->add(new Article(
                $article['title'],
                $article['description'],
                $article['picture'],
                new Carbon($article['created_at']),
                (int) $article['id'],
                $article['updated_at']
            ));
        }

        return new ViewResponse('articles/index', [
            'articles' => $articlesCollection
        ]);
    }

    public function show(int $id): Response
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAllAssociative();

        $article = new Article(
            $data['title'],
            $data['description'],
            $data['picture'],
            new Carbon($data['created_at']),
            (int) $data['id'],
            $data['updated_at']
        );

        return new ViewResponse('article/show', [
            'article' => $article
        ]);
    }
    public function create(): Response
    {
        return new Response('articles/create');
    }

    public function store()
    {
        // $_POST validate

        $this->database->createQueryBuilder()
            ->insert('articles')
            ->values(
                [
                'title' => ':title',
                'description' => ':description',
                'picture' => ':picture',
                'createdAt' =>  ':createdAt',
            ]
            )->setParameters([
               'title' => $_POST['title'],
               'description' => $_POST['description'],
               'picture' => 'https://via.assets.so/img.jpg?w=500&h=500',
                'createdAt' => Carbon::now()
            ])->executeQuery();

        return new RedirectResponse('/articles');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

}