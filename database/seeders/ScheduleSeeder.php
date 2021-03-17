<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule = [
            [
                'name'          => 'Bongeh\'s Breakfast Bonanza',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 14, 9, 0, 0),
                'duration'      => 18000,
                'description'   => 'On Monday mornings Bongeh often plays through entire single player games.',
                'special'       => false,
            ],
            [
                'name'          => 'Monday Multiplayer Madnes',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 14, 14, 0, 0),
                'duration'      => 14400,
                'description'   => 'Tommy joins Bongeh to switch it up to some multiplayer madness',
                'special'       => false,
            ],
            [
                'name'          => 'Tuesday Afternoon',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 15, 12, 0, 0),
                'duration'      => 18000,
                'description'   => null,
                'special'       => false,
            ],
            [
                'name'          => 'Battlefield Tuesday',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 15, 20, 0, 0),
                'duration'      => 10800,
                'description'   => 'Traditionally a Battlefield 4 stream slot, this often encompasses games which allow 32-64 players on a server: Battlefront, Hardline and more. Meaning we can play with as many viewers as possible.',
                'special'       => false,
            ],
            [
                'name'          => 'The Wednesday Stream',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 16, 14, 0, 0),
                'duration'      => 14400,
                'description'   => null,
                'special'       => false,
            ],
            [
                'name'          => 'The Indie Horror Quest',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 16, 23, 0, 0),
                'duration'      => 14400,
                'description'   => 'It all gets a bit 2SPOOKY4U on Wednesday nights as Tommy engages on a noble quest to play every indie horror game avaliable and see if it gets a thumbs up or thumbs down.<br /><br /><strong>Note:</strong> This often involves adult beverages and child like screams. Kappa.',
                'special'       => false,
            ],
            [
                'name'          => 'Thursday Afternoon',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 17, 12, 0, 0),
                'duration'      => 18000,
                'description'   => null,
                'special'       => false,
            ],
            [
                'name'          => 'The Thursday Stream',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 17, 20, 0, 0),
                'duration'      => 10800,
                'description'   => 'Thursdays revolve around multiplayer games that are smaller in scale from the Tuesday streams. 4-6 player oriented games or 2 player co-op; something we can play while you grab a drink and some snacks. Sit back and laugh \'til you weep as you watch the rage and/or joy unfold.',
                'special'       => false,
            ],
            [
                'name'          => 'The Friday Stream',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 18, 12, 0, 0),
                'duration'      => 18000,
                'description'   => 'The final day of the week.<br /><br />You\'re bored in the office, that clock is ticking slower and slower... Open an incognito tab, no-one  will know, Bong and Tommy have got you covered. Some light entertainment to see you sailing gleefully into that well deserved weekend.',
                'special'       => false,
            ],
            [
                'name'          => 'Sub Sunday',
                'interval'      => 604800,
                'start'         => Carbon::create(2016, 11, 20, 17, 0, 0),
                'duration'      => 10800,
                'description'   => 'A stream dedicated to playing games with you, the Eggs. As a way of thanking people for subscribing on twitch and helping us pay our bills, you guys get first dibs at slots in servers and parties.',
                'special'       => false,
            ],
        ];

        foreach ($schedule as $event) {
            Schedule::factory()->create($event);
        }
    }
}
