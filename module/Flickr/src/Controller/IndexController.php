<?php

namespace Flickr\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Flickr\Form\FlickrForm;
use Flickr\Model\Flickr;

class IndexController extends AbstractActionController
{
    public function __construct(private Flickr $flickr)
    {
    }

    public function indexAction()
    {
        return new ViewModel();
    }
    public function searchAction()
    {
        $phrase = $this->params()->fromQuery('phrase');
        $galeria = $this->flickr->wyszukajObrazy($phrase);
        if (isset($galeria->photos)){
            $view = new ViewModel(['phrase' => $phrase, 'galeria' => $galeria->photos]);
        }else{
            $view = new ViewModel(['phrase' => $phrase]);
        }
        return $view;

//        if (!empty($phrase)) {
//            $images = $this->image->search($phrase, $pageToken);
//
//            $listView = new ViewModel(['films' => $films, 'phrase' => $phrase, 'title' => 'wyszukano: ' . $phrase, 'action' => 'search']);
//            $listView->setTemplate('youtube/index/index');
//
//            $view->addChild($listView, 'list');
//        }
    }
    public function userAction()
    {
        $phrase = $this->params()->fromQuery('phrase');
        $galeria = $this->flickr->wyszukajObrazyUsera($phrase);
        if (isset($galeria->photos)){
            $view = new ViewModel(['phrase' => $phrase, 'galeria' => $galeria->photos]);
        }else{
            $view = new ViewModel(['phrase' => $phrase]);
        }
        return $view;
    }
}
