<?php


namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


class User extends AbstractEntity implements UserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $email;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var \DateTime
     */
    private $lastLogin;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = [$this::ROLE_USER];
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password): void
    {
        $this->plainPassword = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles):void
    {
        $this->roles = $roles;
    }

    public function setLastLogin(): void
    {
        $this->lastLogin = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = '';
    }
}
