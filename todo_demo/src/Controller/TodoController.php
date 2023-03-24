<?php

namespace App\Controller;

use App\Form\TodoItemType;
use App\Repository\TodoItemRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodoController extends AbstractController
{
    #[Route('/todo')]
    public function todo(Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = new TodoItemRepository($doctrine);

        $form = $this->createForm(TodoItemType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            if($item->getId() == null) { // new item
                $item->setStatus(0);
                $item->setCreationTs(time());

                $repo->save($item, true);
                // #TODO handle error situation (e.g. db is not avail)
            } else {
                $record = $repo->findById($item->getId());

                if($record != null) {
                    // for now, in this situation only title and description can be changed
                    $record->setTitle($item->getTitle());
                    $record->setDescription($item->getDescription());
                } // else #TODO handle error situation

                $repo->save($record, true);
                // #TODO handle error situation (e.g. db is not avail)
            }

            unset($form);
            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo_list/todo.html.twig', [
            'pending_items'   => $repo->getAllPendingTodoItems(),
            'started_items'   => $repo->getAllOngoingTodoItems(),
            'completed_items' => $repo->getAllCompletedTodoItems(),
            'todoitem_form'   => $form
        ]);
    }

    #[Route('/todo/update')]
    public function update_todo(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $repo = new TodoItemRepository($doctrine);

        $id     = $request->request->get('id');
        $status = $request->request->get('status');

        $record = $repo->findById($id);
        switch($status) {
            case '1':
                $record->setStatus(1);
                $record->setStartTs(time());

                $repo->save($record, true);
                // #TODO handle error situation (e.g. db is not avail)
                break;
            case '2':
                $record->setStatus(2);
                $record->setCompletedTs(time());

                $repo->save($record, true);
                // #TODO handle error situation (e.g. db is not avail)
                break;
            default:
                break;
        }

        $array = array('success'=>true);
        return new JsonResponse($array);
    }

    #[Route('/todo/remove')]
    public function remove_todo(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $repo = new TodoItemRepository($doctrine);

        $id = $request->request->get('id');

        $record = $repo->findById($id);

        $repo->remove($record, true);
        // #TODO handle error situation (e.g. db is not avail)

        $array = array('success'=>true);
        return new JsonResponse($array);
    }
}