<?php

namespace App\DataFixtures;

use App\Entity\ShopItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $item1 = AppFixtures::createShopItem("led lamp", "very bright white led lamp.", 0.50, 48);
        $item2 = AppFixtures::createShopItem("transistor", "NPN transistor for general purpose amplification and switching.", 0.10, 150);
        $item3 = AppFixtures::createShopItem("resistor 220 ohm", "carbon film resistor with 220 ohm resistance.", 0.05, 300);
        $item4 = AppFixtures::createShopItem("capacitor 10uF", "electrolytic capacitor with 10 microfarad capacitance.", 0.07, 200);
        $item5 = AppFixtures::createShopItem("breadboard", "solderless breadboard for prototyping electronic circuits.", 2.00, 25);


        $manager->persist($item1);
        $manager->persist($item2);
        $manager->persist($item3);
        $manager->persist($item4);
        $manager->persist($item5);

        $manager->flush();
    }

    public static function createShopItem(string $name, string $description, float $price, int $availableItems): ShopItem
    {
        $shopItem = new ShopItem();
        $shopItem->setName($name);
        $shopItem->setDescription($description);
        $shopItem->setPrice($price);
        $shopItem->setAvailableItems($availableItems);

        return $shopItem;
    }
}
