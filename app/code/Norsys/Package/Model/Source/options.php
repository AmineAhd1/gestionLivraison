<?php

declare(strict_types=1);

namespace Norsys\Package\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class options implements OptionSourceInterface {

    /**
     * @return \string[][]
     */
    public function toOptionArray(): array {
        return [
            ['value' => '-- Choose City --', 'label' => '--Choose City--'],
            ['value' => 'Casablanca', 'label' => 'Casablanca'],
            ['value' => 'El Kelaa des Srarhna', 'label' => 'El Kelaa des Srarhna'],
            ['value' => 'Fès', 'label' => 'Fès'],
            ['value' => 'Tanger', 'label' => 'Tanger'],
            ['value' => 'Marrakech', 'label' => 'Marrakech'],
            ['value' => 'Sale', 'label' => 'Sale'],
            ['value' => 'Rabat', 'label' => 'Rabat'],
            ['value' => 'Ouarzazate', 'label' => 'Ouarzazate'],
            ['value' => 'Meknès', 'label' => 'Meknès'],
            ['value' => 'Kenitra', 'label' => 'Kenitra'],
            ['value' => 'Agadir', 'label' => 'Agadir'],
            ['value' => 'Oujda', 'label' => 'Oujda'],
            ['value' => 'Tétouan', 'label' => 'Tétouan'],
            ['value' => 'Temara', 'label' => 'Temara'],
            ['value' => 'Safi', 'label' => 'Safi'],
            ['value' => 'Laâyoune', 'label' => 'Laâyoune'],
            ['value' => 'Mohammedia', 'label' => 'Mohammedia'],
            ['value' => 'Kouribga', 'label' => 'Kouribga'],
            ['value' => 'Béni Mellal', 'label' => 'Béni Mellal'],
            ['value' => 'El Jadida', 'label' => 'El Jadida'],
            ['value' => 'Ait Melloul', 'label' => 'Ait Melloul'],
            ['value' => 'Nador', 'label' => 'Nador'],
            ['value' => 'Taza', 'label' => 'Taza'],
            ['value' => 'Settat', 'label' => 'Settat'],
            ['value' => 'Barrechid', 'label' => 'Barrechid'],
            ['value' => 'Al Khmissat', 'label' => ' Al Khmissat'],
            ['value' => 'Inezgane', 'label' => 'Inezgane'],
            ['value' => 'Ksar El Kebir', 'label' => 'Ksar El Kebir'],
            ['value' => 'Guelmim', 'label' => 'Guelmim'],
            ['value' => 'Khénifra', 'label' => 'Khénifra'],
            ['value' => 'Berkane', 'label' => 'Berkane'],
            ['value' => 'Bouskoura', 'label' => 'Bouskoura'],
            ['value' => 'Al Fqih Ben Çalah', 'label' => 'Al Fqih Ben Çalah'],
            ['value' => 'Oued Zem', 'label' => 'Oued Zem'],
            ['value' => 'Sidi Slimane', 'label' => 'Sidi Slimane'],
            ['value' => 'Errachidia', 'label' => 'Errachidia'],
            ['value' => 'Guercif', 'label' => 'Guercif'],
            ['value' => 'Tiflet', 'label' => 'Tiflet'],
            ['value' => 'Sefrou', 'label' => 'Sefrou'],
            ['value' => 'Essaouira', 'label' => 'Essaouira'],
            ['value' => 'Fnidq', 'label' => 'Fnidq'],
            ['value' => 'Ben Guerir', 'label' => 'Ben Guerir'],
            ['value' => 'Ad Dakhla', 'label' => 'Ad Dakhla'],
            ['value' => 'Tiznit', 'label' => 'Tiznit'],
            ['value' => 'Tan-Tan', 'label' => 'Tan-Tan'],
            ['value' => 'Martil', 'label' => 'Martil'],
            ['value' => 'Skhirate', 'label' => 'Skhirate'],
            ['value' => 'Ouezzane', 'label' => 'Ouezzane'],
            ['value' => 'Benslimane', 'label' => 'Benslimane'],
            ['value' => 'Midalt', 'label' => 'Midalt'],
            ['value' => 'Azrou', 'label' => 'Azrou'],
            ['value' => 'Semara', 'label' => 'Semara'],
            ['value' => 'Mrirt', 'label' => 'Mrirt'],
            ['value' => 'Jerada', 'label' => 'Jerada'],
            ['value' => 'Tineghir', 'label' => 'Tineghir'],
            ['value' => 'Chefchaouene', 'label' => 'Chefchaouene'],
            ['value' => 'Azemmour', 'label' => 'Azemmour'],
            ['value' => 'Zagora', 'label' => 'Zagora'],
            ['value' => 'Aziylal', 'label' => 'Aziylal'],
            ['value' => 'Taounate', 'label' => 'Taounate'],
            ['value' => 'Bouznika', 'label' => 'Bouznika'],
            ['value' => 'Mediouna', 'label' => 'Mediouna'],
            ['value' => 'Asilah', 'label' => 'Asilah'],
            ['value' => 'Taza', 'label' => 'Taza'],
            ['value' => 'Al Hoceïma', 'label' => 'Al Hoceïma'],
            ['value' => 'Moulay Bousselham', 'label' => 'Moulay Bousselham'],
            ['value' => 'Qasbat Tadla', 'label' => 'Qasbat Tadla'],
            ['value' => 'Arfoud', 'label' => 'Arfoud'],
        ];
    }

}
