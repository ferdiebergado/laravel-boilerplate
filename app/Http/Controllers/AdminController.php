<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PhpInfoService;
use App\Services\ArtisanService;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class AdminController extends Controller
{
    private $phpinfoservice;
    private $artisanservice;
    
    public function __construct(PhpInfoService $phpinfo, ArtisanService $artisan)
    {
        $this->middleware('auth');
        $this->phpinfoservice = $phpinfo;
        $this->artisanservice = $artisan;
    }
    
    public function info()
    {
        $phpinfo = $this->phpinfoservice->quick_dev_insights_phpinfo();
        return view('admin.info', compact('phpinfo'));
    }
    
    /**
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public static function environment()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => array_get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],
            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];
        $composer = file_get_contents(base_path('composer.json'));
        $dependencies = json_decode($composer, true)['require'];
        // $devDeps = json_decode($composer, true)['require-dev'];
        // $dependencies = array_merge_recursive($deps, $devDeps);
        $package = file_get_contents(base_path('package.json'));
        // $js = json_decode($package, true)['dependencies'];
        $packages = json_decode($package, true)['devDependencies'];
        // $packages = array_merge_recursive($devjs, $js);
        return view('admin.environment', compact('envs', 'dependencies', 'packages'));
    }
    
    public function run_command(Request $request)
    {
        $this->validate($request, [
            'command'   => 'string|nullable'
            ]);
        $command = $request->command;
        $output = '<p>&gt; artisan ' . $command . ' </p>' . $this->artisanservice->run((string) $command);
        if (request()->wantsJson()) {
            return [
                    'data' => $output
                ];
        }
        return $output;
    }
    public function run_tinker(Request $request)
    {
        $code = $request->c;
        try {
            return eval($code);
        } catch (\ParseError $e) {
            return $e->getMessage();
        } catch (\ErrorException $e) {
            return $e->getMessage();
        }
    }
}
