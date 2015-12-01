<?php

namespace SearchApi\Commands;

/**
 * Generic interface for commands
 */
interface Command {
  /**
   * Things that implement command should use execute to carry out its command.
   */
  function execute();
}
