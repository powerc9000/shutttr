<?php  defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Feature Config
 *
 * Each $feature array item must have 2 keys:
 * 'enable' - Either TRUE or FALSE.  Allows you to completely disable a feature.
 * 'bucket' - Either the name of a bucket or an array of buckets.  This can also
 *            be set to '_all_' to open the feature up to ALL users.
 *
 * Examples:
 * 
 * $features['feature1'] = array(
 *  'enable'    => TRUE,
 *  'bucket'    => 'group1'
 * );
 * 
 * $features['feature2'] = array(
 *  'enable'    => TRUE,
 *  'bucket'    => array('group2', 'group3')
 * );
 *
 * $features['feature3'] = array(
 *  'enable'    => TRUE,
 *  'bucket'    => '_all_'
 * );
 */

$features['follow'] = array(
    'enable' => TRUE,
    'bucket' => 'group1'
);

//user type for settings page only admins can view 
$features['settings_type'] = array(
    'enable' => TRUE,
    'bucket' => 'group2'
);
/* End of file features.php */
