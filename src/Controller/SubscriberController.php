<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/subscriber", name="admin_")
 */
class SubscriberController extends AbstractController
{

    /**
     * @var SubscriberRepository
     */
    private SubscriberRepository $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * @Route("/", name="subscriber_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('subscriber/index.html.twig', [
            'subscribers' => $this->subscriberRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subscriber_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->subscriberRepository->insert($subscriber);

            return $this->redirectToRoute('admin_subscriber_index');
        }

        return $this->render('subscriber/new.html.twig', [
            'subscriber' => $subscriber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_show", methods={"GET"})
     */
    public function show(string $id): Response
    {
        return $this->render('subscriber/show.html.twig', [
            'subscriber' => $this->subscriberRepository->find($id),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscriber_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, string $id): Response
    {
        $subscriber = $this->subscriberRepository->find($id);

        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->subscriberRepository->update($subscriber);

            return $this->redirectToRoute('admin_subscriber_index');
        }

        return $this->render('subscriber/edit.html.twig', [
            'subscriber' => $subscriber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_delete", methods={"DELETE"})
     */
    public function delete(Request $request, string $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->subscriberRepository->delete($id);
        }

        return $this->redirectToRoute('admin_subscriber_index');
    }
}
