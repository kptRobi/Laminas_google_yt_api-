<?php

namespace Maps\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Maps\Form\LokalizacjaForm;
use Maps\Model\Lokalizacje;

class IndexController extends AbstractActionController
{


    public function __construct(private Lokalizacje $lokalizacje, private LokalizacjaForm $form)
    {
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function pobierzAction()
    {
        $viewModel = new ViewModel(['lokalizacje' => $this->lokalizacje->pobierzLokalizacje()]);
        $viewModel->setTemplate('maps/index/index.phtml');
        return $viewModel;
    }

    public function dodajAction(){
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->form->setData($request->getPost());

            if ($this->form->isValid()) {
                $a = $this->lokalizacje->dodaj($request->getPost());
                if ($a == "NOK"){
                    $viewModel = new ViewModel(['form' => $this->form, "status" => "NOK"]);
                    return $viewModel;
                }
                return $this->redirect()->toRoute('maps');
            }
        }
        $viewModel = new ViewModel(['form' => $this->form, "status" => "OK"]);
        return $viewModel;
    }
}
