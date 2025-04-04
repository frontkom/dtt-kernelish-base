<?php

namespace frontkom\DttKernelishBase;

use weitzman\DrupalTestTraits\ExistingSiteBase;

abstract class KernelishBase extends ExistingSiteBase
{

  /**
   * {@inheritdoc}
   */
    public function setupMinkSession(): void
    {
      // Do nothing. Well except making sure the base URL is set. The actual value
      // of it is kind of important to have not work, since we are interested in
      // crashing tests if they try to use it. If you are wondering about the
      // origin of the URL, its a quote from the poster in Fox Mulders basement
      // office in the series The X-Files. The port number is the year the series
      // started.
        $this->baseUrl = 'http://the.truth.is.out.there:1993';
    }

  /**
   * {@inheritdoc}
   */
    public function tearDownMinkSession(): void
    {
    }

  /**
   * {@inheritdoc}
   */
    public function tearDown(): void
    {
        $has_failed = false;
      // For phpunit <= 9:
        if (method_exists($this, 'hasFailed')) {
            $has_failed = $this->hasFailed();
        }
        $database = $this->container->get('database');
        if ($has_failed) {
            if ($database->schema()->tableExists('watchdog')) {
                $messages = $database
                ->select('watchdog', 'w')
                ->fields('w')
                ->orderBy('w.wid', 'DESC')
                ->range(0, 10)
                ->execute()
                ->fetchAll();
                if (!empty($messages)) {
                    foreach ($messages as $error) {
                    // Perform replacements so the error message is easier to
                    // read in the log.
                    // @codingStandardsIgnoreLine
                    $error->variables = unserialize($error->variables);
                        $error->message = str_replace(
                            array_keys($error->variables),
                            $error->variables,
                            $error->message
                        );
                        unset($error->variables);
                        print_r($error);
                    }
                }
            } else {
              // Print a warning if the watchdog table does not exist.
                print_r('Watchdog table does not exist. Please check your test environment.');
            }
        }
        parent::tearDown();
    }

    
  /**
   * {@inheritdoc}
   */
    public function drupalGet($path, array $options = [], array $headers = [])
    {
        // This function should probably not be needed to be implemented, since the
        // base URL will be set to a non-working value. But since that will give a
        // not super helpful error message, we will throw an exception here to make
        // it more clear what is going on.
        throw new \Exception('Kernelish tests does not support HTTP requests');
    }
}
