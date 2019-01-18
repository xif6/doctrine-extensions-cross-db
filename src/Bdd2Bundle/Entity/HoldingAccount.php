<?php

namespace Bdd2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HoldingAccount
 *
 * @ORM\Table(name="holding_account")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\HoldingAccountRepository")
 */
class HoldingAccount extends LinkedAccount
{
}

