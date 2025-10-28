<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class ConfigurationController extends Controller
{
    /**
     * Display the configuration page.
     */
    public function index()
    {
        $config = [
            'app_name' => config('app.name'),
            'interest_rates' => config('loan-evaluation.interest_rates'),
            'loan_limits' => config('loan-evaluation.loan_limits'),
            'evaluation_rules' => config('loan-evaluation.evaluation_rules'),
            'notification_settings' => config('loan-evaluation.notification_settings'),
        ];

        return view('admin.configuration.index', compact('config'));
    }

    /**
     * Update configuration settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'interest_rates.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // Get current config
        $configPath = config_path('loan-evaluation.php');
        $config = include $configPath;
        
        // Update interest rates
        if (isset($validated['interest_rates'])) {
            foreach ($validated['interest_rates'] as $key => $value) {
                if ($value !== null) {
                    $config['interest_rates'][$key] = $value;
                }
            }
        }

        // Write updated config to file
        $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        file_put_contents($configPath, $content);

        // Clear config cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()
            ->route('admin.configuration.index')
            ->with('success', 'Tasas de interés actualizadas exitosamente. Los nuevos préstamos usarán estos valores.');
    }
}

