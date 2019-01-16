<?php

namespace AppBundle\Controller;

use Bdd1Bundle\Entity\User;
use Bdd2Bundle\Entity\Category;
use Bdd2Bundle\Entity\Game;
use Bdd2Bundle\Entity\Gamer;
use Bdd2Bundle\Entity\Tag;
use Bdd2Bundle\Entity\UserTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em1 = $this->getDoctrine()->getManager('default1');
        $em2 = $this->getDoctrine()->getManager('default2');
        //*

        /** @var User[] $users */
        $users = $this->getDoctrine()->getRepository(User::class, 'default1')->findAll();
        /** @var Category[] $categories */
        $categories = $this->getDoctrine()->getRepository(Category::class, 'default2')->findAll();
        /** @var Tag[] $tags */
        $tags = $this->getDoctrine()->getRepository(Tag::class, 'default2')->findAll();
//*/
        $user = $users[1];
        $category = $categories[2];
        $tag = $tags[2];

//        $user->setCategory($category);
        // remove et set ne marche pas
//        $user->removeTag($tag);
        $user->addTag($tag);
//        $tag->removeUser($user);
//        $category->addUser($user);

//        $em2->persist($category);
        $em2->persist($tag);
        $em1->persist($user);
        $em1->flush();
        $em2->flush();

//        dump($user->getTags());
//        dump($tag->getId(), $tag->getUserTags()->count());
//        dump($tag->getUsers());

        $em1->clear();
        $em2->clear();
//*/

        $users = $this->getDoctrine()->getRepository(User::class, 'default1')->findAll();
        $categories = $this->getDoctrine()->getRepository(Category::class, 'default2')->findAll();
        $tags = $this->getDoctrine()->getRepository(Tag::class, 'default2')->findAll();
//        $userTag = $this->getDoctrine()->getRepository(UserTag::class, 'default2')->findAll();
//        dump($categories, $categories[0]->getUsers()[0]->getName());
        // replace this example code with whatever you need
//        dump($users[0]->getTags());


//        dump($tags[0]->getUsers());die;
        return $this->render('default/index.html.twig', [
            'users' => $users,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * @Route("/gamer", name="addGamer")
     */
    public function addGamerAction(Request $request)
    {
        $em2 = $this->getDoctrine()->getManager('default2');
//        $game = new Game();
//        $game->setName('FF 1');
        /** @var Game[] $games */
        $games = $this->getDoctrine()->getRepository(Game::class, 'default2')->findAll();
        /** @var Gamer[] $gamers */
        $gamers = $this->getDoctrine()->getRepository(Gamer::class, 'default2')->findAll();

        $game = $games[0];
        $gamer = $gamers[0];
//        $game->addGamer($gamer);
        $game->removeGamer($gamer);
//        $gamer = new Gamer();
//        $gamer->setName('xif1');
//        $gamer->setGame($game);

        $em2->persist($game);
//        $em2->persist($gamer);
        $em2->flush();

        dump($this->getDoctrine()->getRepository(Game::class, 'default2')->findAll());
        dump($this->getDoctrine()->getRepository(Gamer::class, 'default2')->findAll());
        return new Response();
    }
}
