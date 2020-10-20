<?php

namespace App\Traits;


trait ProgressTrait
{
    public function progress()
    {
        switch ($this->status) {
            case 'WSTF Approved':
                $progress = 100;
                break;
            case 'WASREB Approved':
                $progress = 75;
                break;
            case 'Needs Approval':
                $progress = 50;
                break;
            default:
                $progress = 25;
        }
        return $progress;
    }

}
