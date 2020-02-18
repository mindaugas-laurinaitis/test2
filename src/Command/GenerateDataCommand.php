<?php

namespace App\Command;

use App\Entity\Subscriber;
use App\Repository\SubscriberRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDataCommand extends Command
{
    protected static $defaultName = 'app:generate';
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var SubscriberRepository
     */
    private SubscriberRepository $subscriberRepository;

    public function __construct(UserRepository $userRepository, SubscriberRepository $subscriberRepository, string $name = null)
    {
        parent::__construct($name);
        $this->userRepository = $userRepository;
        $this->subscriberRepository = $subscriberRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = 'example@example.com';
        $this->userRepository->create('test', $email, true);
        $output->writeln(sprintf('Created user <comment>%s</comment>', $email));

        for ($i = 0; $i < 10; $i++) {
            $name = 'Name nr. ' . $i;
            $sub = (new Subscriber())
                ->setName($name)
                ->setEmail(sprintf('sub+%s@example.com', $i))
                ->setCategories([]);
            $this->subscriberRepository->insert($sub);

            $output->writeln(sprintf('Created sub <comment>%s</comment>', $name));
        }

        return 0;
    }
}
