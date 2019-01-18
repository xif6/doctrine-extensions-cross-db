<?php

namespace Bdd1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HoldingAccount
 *
 * @ORM\Table(name="holding_account")
 * @ORM\Entity(repositoryClass="Bdd1Bundle\Repository\HoldingAccountRepository")
 */
class HoldingAccount extends LinkedAccount
{
}

