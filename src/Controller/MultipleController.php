<?php

namespace App\Controller;

use App\Entity\Multiple;
use App\Form\MultipleType;
use App\Repository\MultipleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/multiple')]
class MultipleController extends AbstractController
{
    #[Route('/', name: 'app_multiple_index', methods: ['GET'])]
    public function index(MultipleRepository $multipleRepository): Response
    {
        return $this->render('multiple/index.html.twig', [
            'multiples' => $multipleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_multiple_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $multiple = new Multiple();
        $form = $this->createForm(MultipleType::class, $multiple);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($multiple);
            $entityManager->flush();

            return $this->redirectToRoute('app_multiple_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('multiple/new.html.twig', [
            'multiple' => $multiple,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_multiple_show', methods: ['GET'])]
    public function show(Multiple $multiple): Response
    {
        return $this->render('multiple/show.html.twig', [
            'multiple' => $multiple,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_multiple_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Multiple $multiple, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MultipleType::class, $multiple);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_multiple_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('multiple/edit.html.twig', [
            'multiple' => $multiple,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_multiple_delete', methods: ['POST'])]
    public function delete(Request $request, Multiple $multiple, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$multiple->getId(), $request->request->get('_token'))) {
            $entityManager->remove($multiple);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_multiple_index', [], Response::HTTP_SEE_OTHER);
    }
}
