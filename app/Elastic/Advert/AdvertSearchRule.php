<?php

namespace App\Elastic\Advert;

use ScoutElastic\SearchRule;

class AdvertSearchRule extends SearchRule
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
