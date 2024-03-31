<?php

namespace App\Http\Controllers;

class AbsctractController extends \Illuminate\Routing\Controller
{
    private $dispatcher;
    
    public function __construct(\Rosamarsky\CommandBus\CommandBus $dispatcher) 
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function dispatch(\Rosamarsky\CommandBus\Command $command)
    {
        return $this->dispatcher->execute($command);
    }
}