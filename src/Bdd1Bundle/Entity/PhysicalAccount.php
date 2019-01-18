<?php

namespace Bdd1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HoldingAccount
 *
 * @ORM\Table(name="physical_account")
 * @ORM\Entity(repositoryClass="Bdd1Bundle\Repository\PhysicalAccountRepository")
 */
class PhysicalAccount extends LinkedAccount
{

    /**
     * @ORM\Column(name="kyc_state_m", type="string", length=255)
     */
    protected $kycStateM;

    /**
     * @return mixed
     */
    public function getKycStateM()
    {
        return $this->kycStateM;
    }

    /**
     * @param mixed $kycStateM
     */
    public function setKycState($kycStateM)
    {
        $this->kycStateM = $kycStateM;
    }
}

