<?php

namespace CartbotPrivate\Infrastructure\Controller\Admin;

use CartbotPrivate\Domain\User\PasswordEqualActualException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CartbotPrivate\Application\CommandHandlers\Admin\ChangePass;
use CartbotPrivate\Application\CommandHandlers\Admin\FindEvents;
use CartbotPrivate\Application\CommandHandlers\Admin\LastEvents;
use CartbotPrivate\Application\CommandHandlers\Admin\LastSevenDaysEvents;
use CartbotPrivate\Domain\Action\ActionType;
use CartbotPrivate\Domain\Action\FilterActions;
use Cartbot\Domain\DomainException;
use CartbotPrivate\Domain\User\PasswordNotValidException;
use CartbotPrivate\Domain\User\PasswordPlainText;

class DashBoardController extends Controller
{
    public function inicio(): Response
    {
        return $this->render('dashboard.html.twig', ['active' => 1]);
    }

    public function lastEvents(LastEvents $lastEvents): Response
    {
        $lastEvents = $lastEvents->__invoke($this->getUser()->client()->id());
        return new JsonResponse($lastEvents);
    }

    public function lastSevenDaysEvents(LastSevenDaysEvents $lastSeven): Response
    {
        $lastAdded = $lastSeven->__invoke($this->getUser()->client()->id());
        return new JsonResponse($lastAdded);
    }

    public function events(): Response
    {
        return $this->render(
            'listEvents.html.twig',
            [
                'actionTypes' => ActionType::allTypes(),
                'itemsByPage' => FindEvents::ITEMS_BY_PAGE,
                'active' => 2
            ]
        );
    }

    public function findEvents(Request $request, FindEvents $findEvents): Response
    {
        try {
            $filter = new FilterActions(
                $request->query->get('user'),
                $request->query->get('chat'),
                $request->query->get('description')
            );
            $resul = $findEvents->__invoke(
                $request->query->get('eventType'),
                $request->query->get('dateStart'),
                $request->query->get('dateEnd'),
                $request->query->get('page'),
                $request->query->get('order'),
                $filter,
                $this->getUser()->client()->id()
            );
        } catch (DomainException $ex) {
            return new JsonResponse($ex->getMessage(), 400, [], true);
        }

        return new JsonResponse($resul);
    }

    public function configure(): Response
    {
        return $this->render('configure.html.twig', ['active' => 3]);
    }

    public function changePass(Request $request, ChangePass $changePass): Response
    {
        $errors = new \ArrayObject();
        $actualPass = $this->validatePass($request, 'password', $errors);
        $newPass = $this->validatePass($request, 'newPassword', $errors);
        $repeatPass = $this->validatePass($request, 'repeatPassword', $errors);
        if ($errors->count() > 0) {
            return new JsonResponse($errors->getArrayCopy(), 400);
        }

        if (!$newPass->equal($repeatPass)) {
            $text = 'Las contraseñas no son iguales';
            return new JsonResponse(['newPassword' => $text, 'repeatPassword' => $text], 400);
        }

        try {
            return new JsonResponse($changePass->__invoke($actualPass, $newPass, $this->getUser()));
        } catch (PasswordNotValidException $ex) {
            return new JsonResponse(['password' => 'Valor no valido'], 400);
        } catch (PasswordEqualActualException $ex) {
            return new JsonResponse(['password' => $ex->getMessage()], 400);
        } catch (DomainException $ex) {
            return new JsonResponse($ex->getMessage(), 400, [], true);
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => 'error'], 500);
        }
    }

    private function validatePass(Request $request, string $key, \ArrayObject $errors): ?PasswordPlainText
    {
        try {
            return new PasswordPlainText($request->request->get($key));
        } catch (\Exception $ex) {
            $errors[$key] = ($key === 'password') ? 'Valor no valido' : $ex->getMessage();
            return null;
        }
    }
}
