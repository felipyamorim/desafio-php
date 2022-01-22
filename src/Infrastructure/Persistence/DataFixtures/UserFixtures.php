<?php

namespace App\Infrastructure\Persistence\DataFixtures;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $item) {
            $user = new User();

            $user
                ->setName($item['name'])
                ->setEmail(new Email($item['email']))
                ->setDocument(new Document($item['document']))
                ->setType(strlen($user->getDocument()) === 11 ? User::TYPE_COMMON : User::TYPE_SHOPKEEPER)
                ->addBalance($item['balance'])
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getData() {
        return [
            [
                'name' => 'João Alves',
                'document' => '448.722.230-39',
                'email' => 'jalves@bestemail.com',
                'balance' => '100.00'
            ],
            [
                'name' => 'Maria Pereira',
                'document' => '515.626.390-99',
                'email' => 'mpereira@bestemail.com',
                'balance' => '240.00'
            ],
            [
                'name' => 'Best Hardware',
                'document' => '35.656.310/0001-43',
                'email' => 'contact@besthardware.com',
                'balance' => '1050.00'
            ],
            [
                'name' => 'Brasília Pet Shop',
                'document' => '81.858.016/0001-31',
                'email' => 'contato@bsbpetshop.com',
                'balance' => '830.00'
            ],
            [
                'name' => 'Magno Silva',
                'document' => '943.317.550-61',
                'email' => 'msilva@bestemail.com',
                'balance' => '830.00'
            ],
        ];
    }
}
