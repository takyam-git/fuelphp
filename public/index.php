<?php
/**
 * Part of the FuelPHP framework.
 *
 * @package    Fuel
 * @version    2.0.0
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 */

/**
 * Configure paths
 * (these constants are helpers and are not required by Fuel itself)
 */
define('DOCROOT', __DIR__.'/');
define('FUELPATH', DOCROOT.'../fuelphp/');
define('APPPATH', FUELPATH.'app/');

/**
 * Setup environment
 */
require FUELPATH.'fuel/kernel/classes/Environment.php';
use Fuel\Kernel\Environment;
$env = Environment::instance()->init(array(
	'name'  => isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : 'development',
	'path'  => FUELPATH,
));

/**
 * Initialize Application in package 'app'
 */
$app = $env->loader->load_application('app', function() {});

/**
 * Run the app and output the response
 */
echo $app->request($env->input->uri())->execute()->response()->send_headers();

?>

<p>
	<strong>Time elapsed:</strong> <?php echo round($env->profiler()->time_elapsed(), 5); ?> s<br />
	<strong>Memory usage:</strong> <?php echo round($env->profiler()->mem_usage() / 1000000, 4); ?> MB<br />
	<strong>Peak memory usage:</strong> <?php echo round($env->profiler()->mem_usage(true) / 1000000, 4); ?> MB
</p>

<h3>Events</h3>

<ul>
	<?php
	foreach ($env->profiler()->events() as $timestamp => $event)
	{
		echo '<li>'.$event.'</li>';
	}
	?>
</ul>