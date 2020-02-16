<?php


namespace App\Repository;


use App\Security\User;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UserRepository extends AbstractRepository
{

    private UserPasswordEncoderInterface  $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();

        $this->encoder = $encoder;
    }

    protected function getTargetEntity(): string
    {
        return User::class;
    }

    public function create(string $password, string $email, bool $superadmin)
    {
        $user = new User();

        $user
            ->setEmail($email)
            ->setRoles($superadmin ? [User::ROLE_ADMIN] : []);

        $encoded = $this->encoder->encodePassword($user, $password);

        $user->setPassword($encoded);

        $this->insert($user);
    }

    protected function getPath(string $id, $extension = '.json'): string
    {
        return $this->getEntityPath() . '/'. $this->slugger->slug($id) . $extension;
    }
}