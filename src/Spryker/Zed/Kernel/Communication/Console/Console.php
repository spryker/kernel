<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\Communication\Console;

use Psr\Log\LoggerInterface;
use RuntimeException;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\Kernel\ClassResolver\Communication\CommunicationFactoryResolver;
use Spryker\Zed\Kernel\ClassResolver\Facade\FacadeResolver;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Kernel\Communication\BusinessFactoryResolverAwareTrait;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use Spryker\Zed\Kernel\RepositoryResolverAwareTrait;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Terminal;

/**
 * @method \Symfony\Component\Console\Application getApplication()
 */
class Console extends SymfonyCommand
{
    use RepositoryResolverAwareTrait;
    use BusinessFactoryResolverAwareTrait;

    public const int CODE_SUCCESS = 0;

    public const int CODE_ERROR = 1;

    protected InputInterface $input;

    protected OutputInterface $output;

    protected ?AbstractFacade $facade = null;

    protected ?AbstractCommunicationFactory $factory = null;

    protected ?Container $container = null;

    protected ?AbstractQueryContainer $queryContainer = null;

    protected LoggerInterface|ConsoleLogger|null $messenger = null;

    protected ?InputDefinition $mergedDefinition = null;

    protected int $exitCode = self::CODE_SUCCESS;

    protected function getContainer(): ?Container
    {
        return $this->container;
    }

    public function setFactory(AbstractCommunicationFactory $factory): self
    {
        $this->factory = $factory;

        return $this;
    }

    protected function getFactory(): AbstractCommunicationFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        if ($this->container !== null) {
            $this->factory->setContainer($this->container);
        }

        if ($this->queryContainer !== null) {
            $this->factory->setQueryContainer($this->queryContainer);
        }

        return $this->factory;
    }

    private function resolveFactory(): AbstractCommunicationFactory
    {
        /** @var \Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory $factory */
        $factory = $this->getFactoryResolver()->resolve($this);

        return $factory;
    }

    private function getFactoryResolver(): CommunicationFactoryResolver
    {
        return new CommunicationFactoryResolver();
    }

    public function setFacade(AbstractFacade $facade): self
    {
        $this->facade = $facade;

        return $this;
    }

    protected function getFacade(): AbstractFacade
    {
        if ($this->facade === null) {
            $this->facade = $this->resolveFacade();
        }

        return $this->facade;
    }

    private function resolveFacade(): AbstractFacade
    {
        return $this->getFacadeResolver()->resolve($this);
    }

    private function getFacadeResolver(): FacadeResolver
    {
        return new FacadeResolver();
    }

    public function setQueryContainer(AbstractQueryContainer $queryContainer): self
    {
        $this->queryContainer = $queryContainer;

        return $this;
    }

    protected function getQueryContainer(): ?AbstractQueryContainer
    {
        return $this->queryContainer;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = $output;
    }

    protected function runDependingCommand(string $command, array $arguments = []): int
    {
        $command = $this->getApplication()->find($command);
        $arguments['command'] = $command->getName();
        $input = new ArrayInput($arguments);

        $exitCode = $command->run($input, $this->output);

        $this->setExitCode($exitCode);

        return $exitCode;
    }

    private function setExitCode(int $exitCode): self
    {
        $this->exitCode = $exitCode;

        return $this;
    }

    protected function hasError(): bool
    {
        return $this->exitCode !== static::CODE_SUCCESS;
    }

    protected function getLastExitCode(): int
    {
        return $this->exitCode;
    }

    protected function getMessenger(): LoggerInterface|ConsoleLogger
    {
        if ($this->messenger === null) {
            $this->messenger = new ConsoleLogger($this->output);
        }

        return $this->messenger;
    }

    public function info(array|string $message, bool $wrapInInfoTags = true): void
    {
        if (is_array($message)) {
            $message = implode(PHP_EOL, $message);
        }

        if ($wrapInInfoTags) {
            $message = '<info>' . $message . '</info>';
        }

        $this->output->writeln($message);
    }

    public function error(string $message): void
    {
        $width = $this->getTerminalWidth() - mb_strlen($message) - 1;
        $width = max(0, $width);
        $message .= str_repeat(' ', $width);

        $this->output->writeln(sprintf('<error> %s</error>', $message));
    }

    public function warning(string $message): void
    {
        $style = new OutputFormatterStyle('black', 'yellow');
        $this->output->getFormatter()->setStyle('warning', $style);

        $width = $this->getTerminalWidth() - mb_strlen($message) - 1;
        $width = max(0, $width);
        $message .= str_repeat(' ', $width);

        $this->output->writeln(sprintf('<warning> %s</warning>', $message));
    }

    public function success(string $message): void
    {
        $style = new OutputFormatterStyle('black', 'green');
        $this->output->getFormatter()->setStyle('success', $style);

        $width = $this->getTerminalWidth() - mb_strlen($message) - 1;
        $width = max(0, $width);
        $message .= str_repeat(' ', $width);

        $this->output->writeln(sprintf('<success> %s</success>', $message));
    }

    /**
     * @deprecated Not used anymore.
     *
     * @param string $question
     *
     * @return bool
     */
    public function askConfirmation($question)
    {
        $question = $question . '? <fg=green>[yes|no|abort]</fg=green> ';

        $result = $this->askAbortableConfirmation($this->output, $question);

        return $result;
    }

    /**
     * Asks a confirmation to the user.
     *
     * The question will be asked until the user answers by yes, or no.
     * If he answers nothing, it will use the default value. If he answers abort,
     * it will throw a RuntimeException.
     *
     * @deprecated Not used anymore.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output An Output instance
     * @param string $question The question to ask
     * @param string|null $default The default answer if the user enters nothing
     *
     * @throws \RuntimeException
     *
     * @return bool true if the user has confirmed, false otherwise
     */
    public function askAbortableConfirmation(OutputInterface $output, $question, $default = null)
    {
        $answer = 'z';
        while ($answer && !in_array(strtolower($answer[0]), ['y', 'n', 'a'])) {
            /** @var string $answer */
            $answer = $this->ask($question);
        }

        if (strtolower($answer[0]) === 'a') {
            throw new RuntimeException('Aborted');
        }

        if ($default === null) {
            return $answer && strtolower($answer[0]) === 'y';
        }

        return !$answer || strtolower($answer[0]) === 'y';
    }

    public function ask(string $question, ?string $default = null): ?string
    {
        $questionHelper = $this->getQuestionHelper();
        $question = new Question($question, $default);

        return $questionHelper->ask($this->input, $this->output, $question);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function select(string $question, array $options, string $default): mixed
    {
        $questionHelper = $this->getQuestionHelper();

        $choiceQuestion = new ChoiceQuestion($question, $options, $default);

        return $questionHelper->ask($this->input, $this->output, $choiceQuestion);
    }

    protected function getQuestionHelper(): QuestionHelper
    {
        /** @var \Symfony\Component\Console\Helper\HelperSet $helperSet */
        $helperSet = $this->getHelperSet();

        /** @var \Symfony\Component\Console\Helper\QuestionHelper $questionHelper */
        $questionHelper = $helperSet->get('question');

        return $questionHelper;
    }

    public function printLineSeparator(bool $wrapInInfoTags = true): void
    {
        $width = $this->getTerminalWidth();
        $this->info(str_repeat('-', $width), $wrapInInfoTags);
    }

    protected function getTerminalWidth(): int
    {
        $terminal = new Terminal();

        return $terminal->getWidth();
    }

    /**
     * We can't merge with the Symfony Application definition as it uses the shortcut `e` for the `env` option, and we do
     * have quite some commands that are using this short-cut as well which breaks on merge.
     */
    public function mergeApplicationDefinition(bool $mergeArgs = true): void
    {
        // Get the current Console Command definition
        $definition = parent::getDefinition();

        // Get the Application to check if it exists and to merge the application options with the command options.
        $application = parent::getApplication();

        $this->mergedDefinition = new InputDefinition();
        $this->mergedDefinition->setOptions($definition->getOptions());

        if ($application) {
            $this->mergedDefinition->setArguments($application->getDefinition()->getArguments());
            $this->mergedDefinition->addArguments($definition->getArguments());

            foreach ($application->getDefinition()->getOptions() as $option) {
                // The Symfony Application default option `env` shortcut `e` conflicts with existing options of some console commands, we need to skip this.
                if ($option->getName() === 'env') {
                    continue;
                }

                $this->mergedDefinition->addOption($option);
            }

            return;
        }

        $this->mergedDefinition->setArguments($definition->getArguments());
    }

    public function getDefinition(): InputDefinition
    {
        // This will be returned when a specific command was requested. Symfony calls the mergeApplicationDefinition before it uses
        // the command.
        if ($this->mergedDefinition) {
            return $this->mergedDefinition;
        }

        // This one needs to be returned when the Console Application is called without a command name to run.
        return $this->getNativeDefinition();
    }
}
