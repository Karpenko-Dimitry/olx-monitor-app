<?php

namespace App\Console\Commands;

use App\Mail\PriceNotificationMail;
use App\Models\PriceEndpoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ParsePricesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse prices from the website';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $now = now();
        $builder = PriceEndpoint::active()->where('updated_at', '<', $now);
        $paseService = resolve('parse_service');
        $this->line('<fg=White;bg=Cyan>START</> Running...');

        $total = $builder->clone()->count();
        $bar = $this->output->createProgressBar($total);
        $this->info("\nProcess parsing...");
        $timeStart = microtime(true);
        $bar->start();

        $builder->clone()->chunkById(200, function ($items) use ($bar, $paseService) {
            /** @var PriceEndpoint $item */
            foreach ($items as $item) {
                $item->updatePrice($paseService->parsePrice($item->url));
                if ($item->current_price != $item->previous_price) {
                    foreach ($item->users as $user) {
                        Mail::mailer('smtp')->to(
                            $user->email
                        )->send(new PriceNotificationMail($item));
                    }
                }

                sleep(1);
                $bar->advance();
            }
        });

        $bar->finish();
        $diff = microtime(true) - $timeStart;
        $average = $diff && $total ? round($diff / $total, 4) : 0;
        $sec = round($diff, 4);

        $this->line("\n\n<fg=White;bg=Cyan>FINISH</> process. Execution time: $sec sec. Average: $average sec.");

        return CommandAlias::SUCCESS;
    }
}
