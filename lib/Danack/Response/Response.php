<?php

namespace Danack\Response;

interface Response
{
    public function getStatus();
    public function getBody();
    public function getHeaders();
}
