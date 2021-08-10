<?php
/**
 * Copyright Mozok Evgen
 * See license.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\ExternalConnection\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * Throws on prohibited actions with external database
 */
class ProcessingException extends LocalizedException
{

}
