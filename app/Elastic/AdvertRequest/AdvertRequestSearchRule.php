<?php

namespace App\Elastic\AdvertRequest;

use ScoutElastic\SearchRule;

class AdvertRequestSearchRule extends SearchRule
{
    /**
     * @inheritdoc
     */
    public function buildHighlightPayload()
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function buildQueryPayload()
    {
        return parent::buildQueryPayload();
    }
}
