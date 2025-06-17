<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $messages = [
            [
                'name'       => 'Alice Dupont',
                'email'      => 'alice.dupont@example.com',
                'subject'    => 'Question about pricing',
                'message'    => 'Hi, could you send me your latest pricing brochure?',
                'created_at' => $now->copy()->subDays(10),
                'updated_at' => $now->copy()->subDays(10),
            ],
            [
                'name'       => 'Bob Martin',
                'email'      => 'bob.martin@example.com',
                'subject'    => 'Support needed',
                'message'    => 'I\'m having trouble logging into my account.',
                'created_at' => $now->copy()->subDays(9),
                'updated_at' => $now->copy()->subDays(9),
            ],
            [
                'name'       => 'Claire Bernard',
                'email'      => 'claire.bernard@example.com',
                'subject'    => 'Feature request',
                'message'    => 'Could you add dark mode to the dashboard?',
                'created_at' => $now->copy()->subDays(8),
                'updated_at' => $now->copy()->subDays(8),
            ],
            [
                'name'       => 'David Rousseau',
                'email'      => 'd.rousseau@example.com',
                'subject'    => 'Billing inquiry',
                'message'    => 'Why was I charged twice this month?',
                'created_at' => $now->copy()->subDays(7),
                'updated_at' => $now->copy()->subDays(7),
            ],
            [
                'name'       => 'Emma Lefèvre',
                'email'      => 'emma.lefevre@example.com',
                'subject'    => 'Partnership proposal',
                'message'    => 'I’d like to discuss a potential collaboration.',
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(6),
            ],
            [
                'name'       => 'François Petit',
                'email'      => 'francois.petit@example.com',
                'subject'    => 'Bug report',
                'message'    => 'The file upload fails with a 500 error.',
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'name'       => 'Gabrielle Noël',
                'email'      => 'gabrielle.noel@example.com',
                'subject'    => 'Account deletion',
                'message'    => 'Please delete my account permanently.',
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'name'       => 'Hugo Bernard',
                'email'      => 'hugo.bernard@example.com',
                'subject'    => 'Request for API key',
                'message'    => 'Can you provide me an API key for integration?',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'name'       => 'Isabelle Roux',
                'email'      => 'isabelle.roux@example.com',
                'subject'    => 'Thank you!',
                'message'    => 'Thanks for the quick support yesterday.',
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'name'       => 'Julien Moreau',
                'email'      => 'julien.moreau@example.com',
                'subject'    => 'Site feedback',
                'message'    => 'Your new layout looks great on mobile.',
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now->copy()->subDay(),
            ],
        ];

        DB::table('messages')->insert($messages);
    }
}
