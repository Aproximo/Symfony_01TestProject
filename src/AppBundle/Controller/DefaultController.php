<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Form\AccountsType;
use AppBundle\Entity\Accounts;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * article list page
     *
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {

        return [];
    }

    /**
     * article list page
     *
     * @Route("/users", name="users")
     * @Template()
     */
    public function userAction()
    {

        $repo = $this->get('doctrine')->getRepository('AppBundle:User');
        $users = $repo->findAll();


        return compact('users');
    }

    /**
     *
     * article by id
     * sl - for tralling slash if its needed
     *
     * @Route("/users/{id}{sl}", name="user_page", defaults={"sl" : ""}, requirements={"id" : "[1-9][0-9]*","sl":"/?"})
     * @Template()
     */
    public function showAction($id)
    {
        $repo = $this->get('doctrine')->getRepository('AppBundle:User');
        $user = $repo->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return compact('user');
    }

    /**
     *
     * article edit
     * sl - for tralling slash if its needed
     *
     * @Route("/users/edit/{id}{sl}", name="user_edit", defaults={"sl" : ""}, requirements={"id" : "[1-9][0-9]*","sl":"/?"})
     * @Template()
     */
    public function editUserAction($id, Request $request)
    {
        $doctrine = $this->get('doctrine');
        $user = $doctrine->getRepository('AppBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request); // В форму загяняем данные после сабмита, но еще не сохраняем

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Saved");
            return $this->redirectToRoute('user_page', ['id' => $id]);
        }

        return ['article' => $user, 'form' => $form->createView()];


    }

    /**
     *  add new user
     *
     * @Route("/users/add", name="user_add")
     * @Template()
     */
    public function addUserAction(Request $request)
    {   // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_page', ['id' => $user->getId()]);
        }
        return       ['form' => $form->createView()];
//        return $this->render(
//            'AppBundle:admin:add.html.twig',
//            array('form' => $form->createView())
//        );


    }

    /**
     *  add new user
     *
     * @Route("/users/{id}{sl}/accounts/add", name="accounts_add", defaults={"sl" : ""}, requirements={"id" : "[1-9][0-9]*","sl":"/?"})
     * @Template()
     */
    public function addAccountAction($id, Request $request)
    {
        $doctrine = $this->get('doctrine');
        $user = $doctrine->getRepository('AppBundle:User')->find($id);

        // 1) build the form
        $account = new Accounts();
        $account = $account->setUser($user);
        $form = $this->createForm(AccountsType::class, $account);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();

            $em->persist($account);
            $em->flush();


            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_page', ['id' => $user->getId()]);
        }
        return       ['form' => $form->createView()];



    }
}
