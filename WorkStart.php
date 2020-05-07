<?php

namespace App\Console\Commands;

use cijic\phpMorphy\Facade\Morphy;
use Illuminate\Console\Command;

class WorkStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:start {name} {--m|model} {--c|controller} {--mi|migration} {--s|seeder} {--f|factory} {--p|policy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs packages by default';
	
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$word = $this->wordUcfirst($this->argument('name'));
		$plural_word = $this->wordUcfirst($this->pluralWord($word));

    	foreach ($this->options() as $key => $value){
    		if ($value) {
				$name = ($key === 'model') ? ucfirst($word) : ucfirst($plural_word).ucfirst($key);
				$this->call('make:'.$key, ['name' => $name]);
			}
		}
    }

    private function wordUcfirst($word)
	{
		return ucfirst($word);
	}

	private function pluralWord($word)
	{
		$morphy = new \cijic\phpMorphy\Morphy('en');
		$word_dictionary = $morphy->castFormByGramInfo(mb_strtoupper($word), NULL, array('PL'), TRUE);
		$plural_word = $word_dictionary ? mb_strtolower($word_dictionary[0]) : $word;
		return $plural_word;
	}
}
