<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SeuModel;
use Carbon\Carbon;
use App\Models\Room;
class DeleteInactiveEntries extends Command
{

    protected $signature = 'delete:inactive-entries';
    protected $description = 'Deleta registros não acessados por um período definido';
    public function handle()
    {
        
            // Define o período de inatividade 
        $days = 30;
    
        Room::where('last_accessed_at', '<', Carbon::now()->subDays($days))
            ->delete();
    
        $this->info('Registros inativos deletados com sucesso.');
    }
}
