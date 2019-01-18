<?php

namespace AppBundle\Controller;

use Bdd1Bundle\Entity\PhysicalAccount;
use Bdd1Bundle\Entity\User as User1;
use Bdd2Bundle\Entity\User as User2;
use Bdd2Bundle\Entity\Category;
use Bdd2Bundle\Entity\Game;
use Bdd2Bundle\Entity\Gamer;
use Bdd1Bundle\Entity\LinkedAccount as LinkedAccount1;
use Bdd2Bundle\Entity\LinkedAccount as LinkedAccount2;
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

        /** @var User1[] $users */
        $users = $this->getDoctrine()->getRepository(User1::class, 'default1')->findAll();
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

        $users = $this->getDoctrine()->getRepository(User1::class, 'default1')->findAll();
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


    /**
     * @Route("/anaxago", name="anaxago")
     */
    public function anaxagoAction(Request $request)
    {
        $em1 = $this->getDoctrine()->getManager('default1');
        $em2 = $this->getDoctrine()->getManager('default2');
//*
        $user = new User1();
        $user->setName('u-toto-' . uniqid());
        $em1->persist($user);

        $la = new PhysicalAccount();
        $la->setName('ph-' . uniqid());
        $la->setOwner($user);
        $em1->persist($la);

        $em1->flush();
//*/

        $em1->clear();
        $em2->clear();
        $users1 = $this->getDoctrine()->getRepository(User1::class, 'default1')->findAll();
        $users2 = $this->getDoctrine()->getRepository(User2::class, 'default2')->findAll();

        $la1 = $this->getDoctrine()->getRepository(LinkedAccount1::class, 'default1')->findAll();
        $la2 = $this->getDoctrine()->getRepository(LinkedAccount2::class, 'default2')->findAll();

        dump($users1);
        dump($users2);
        dump($la1);
        dump($la2);
        die;
        /** @var User1[] $users1 */
        $users1 = $this->getDoctrine()->getRepository(User1::class, 'default1')->findAll();
        /** @var User2[] $users2 */
        $users2 = $this->getDoctrine()->getRepository(User2::class, 'default2')->findAll();
        /** @var LinkedAccount1[] $la1 */
        $la1 = $this->getDoctrine()->getRepository(LinkedAccount1::class, 'default1')->findAll();
        /** @var LinkedAccount2[] $la2 */
        $la2 = $this->getDoctrine()->getRepository(LinkedAccount2::class, 'default2')->findAll();

        dump($users1[0]);
        dump($users1[0]->getLinkedAccounts()[0]);
        dump($users2[0]->getLinkedAccounts()[0]);
        dump($users1[0]->getName());
        dump($users2[0]->getName());



        dump($la1[0]);
        dump($la2[0]);

//        dump($users1[0]->getLinkedAccounts()[0]->getOwner()->getName());
//        dump($users2[0]->getLinkedAccounts()[0]->getOwner()->getName());

        die;
    }
}
