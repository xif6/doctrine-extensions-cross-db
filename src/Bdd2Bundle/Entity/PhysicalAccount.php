<?php

namespace Bdd2Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HoldingAccount
 *
 * @ORM\Table(name="physical_account")
 * @ORM\Entity(repositoryClass="Bdd2Bundle\Repository\PhysicalAccountRepository")
 */
class PhysicalAccount extends LinkedAccount
{
    /**
     * @ORM\Column(name="kyc_state", type="string", length=255, nullable=true)
     */
    protected $kycState;

    /**
     * @return mixed
     */
    public function getKycState()
    {
        return $this->kycState;
    }

    /**
     * @param mixed $kycState
     */
    public function setKycState($kycState)
    {
        $this->kycState = $kycState;
    }
}

