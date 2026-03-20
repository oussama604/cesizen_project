<?php

namespace Database\Seeders;

use App\Models\StressEvent;
use Illuminate\Database\Seeder;

class StressEventSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $events = [
            ['label' => 'Deces du conjoint', 'score' => 100],
            ['label' => 'Divorce', 'score' => 73],
            ['label' => 'Separation', 'score' => 65],
            ['label' => 'Sejour en prison', 'score' => 63],
            ['label' => 'Deces d\'un proche parent', 'score' => 63],
            ['label' => 'Maladies ou blessures personnelles', 'score' => 53],
            ['label' => 'Mariage', 'score' => 50],
            ['label' => 'Perte d\'emploi', 'score' => 47],
            ['label' => 'Reconciliation avec le conjoint', 'score' => 45],
            ['label' => 'Retraite', 'score' => 45],
            ['label' => 'Modification de l\'etat de sante d\'un membre de la famille', 'score' => 44],
            ['label' => 'Grossesse', 'score' => 40],
            ['label' => 'Difficultes sexuelles', 'score' => 39],
            ['label' => 'Ajout d\'un membre dans la famille', 'score' => 39],
            ['label' => 'Changement dans la vie professionnelle', 'score' => 39],
            ['label' => 'Modification de la situation financiere', 'score' => 38],
            ['label' => 'Mort d\'un ami proche', 'score' => 37],
            ['label' => 'Changement de carriere', 'score' => 36],
            ['label' => 'Modification du nombre de disputes avec le conjoint', 'score' => 35],
            ['label' => 'Hypotheque superieure a un an de salaire', 'score' => 31],
            ['label' => 'Saisie d\'hypotheque ou de pret', 'score' => 30],
            ['label' => 'Modification de ses responsabilites professionnelles', 'score' => 29],
            ['label' => 'Depart de l\'un des enfants', 'score' => 29],
            ['label' => 'Probleme avec les beaux-parents', 'score' => 29],
            ['label' => 'Succes personnel eclatant', 'score' => 28],
            ['label' => 'Debut ou fin d\'emploi du conjoint', 'score' => 26],
            ['label' => 'Premiere ou derniere annee d\'etudes', 'score' => 26],
            ['label' => 'Modification de ses conditions de vie', 'score' => 25],
            ['label' => 'Changements dans ses habitudes personnelles', 'score' => 24],
            ['label' => 'Difficultes avec son patron', 'score' => 23],
            ['label' => 'Modification des heures et des conditions de travail', 'score' => 20],
            ['label' => 'Changement de domicile', 'score' => 20],
            ['label' => 'Changement d\'ecole', 'score' => 20],
            ['label' => 'Changement du type ou de la quantite de loisirs', 'score' => 19],
            ['label' => 'Modification des activites religieuses', 'score' => 19],
            ['label' => 'Modification des activites sociales', 'score' => 18],
            ['label' => 'Hypotheque ou pret inferieur a un an de salaire', 'score' => 17],
            ['label' => 'Modification des habitudes de sommeil', 'score' => 16],
            ['label' => 'Modification du nombre de reunions familiales', 'score' => 15],
            ['label' => 'Modification des habitudes alimentaires', 'score' => 15],
            ['label' => 'Voyage ou vacances', 'score' => 13],
            ['label' => 'Noel', 'score' => 12],
            ['label' => 'Infractions mineures a la loi', 'score' => 11],
        ];

        $labels = array_map(static fn (array $event): string => $event['label'], $events);

        StressEvent::query()
            ->whereNotIn('label', $labels)
            ->update(['is_active' => false]);

        foreach ($events as $event) {
            StressEvent::query()->updateOrCreate(
                ['label' => $event['label']],
                [
                    'score' => $event['score'],
                    'is_active' => true,
                ]
            );
        }
    }
}
