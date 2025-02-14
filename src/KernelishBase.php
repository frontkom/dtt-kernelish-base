<?php

namespace frontkom\DttKernelishBase;

use weitzman\DrupalTestTraits\ExistingSiteBase;

abstract class KernelishBase extends ExistingSiteBase {

  /**
   * {@inheritdoc}
   */
  public function setupMinkSession(): void {
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
  public function tearDownMinkSession(): void {}

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
