<?php
namespace ChriWo\Mailhandler\Tests\Unit\Domain\Model;

use ChriWo\Mailhandler\Domain\Model\Mail;
use Faker\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class MailTest extends UnitTestCase
{
    /**
     * @var Mail
     */
    protected $model;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * setUp function
     */
    public function setUp()
    {
        parent::setUp();
        $this->model = new Mail();
        $this->faker = Factory::create();
    }

    /**
     * tearDown function
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->model);
    }

    /**
     * @test
     */
    public function mailSubjectCouldBeSet()
    {
        $subject = $this->faker->text(100);
        $this->model->setMailSubject($subject);
        $this->assertEquals($subject, $this->model->getMailSubject());
    }

    /**
     * @test
     */
    public function mailReceiverCouldBeSet()
    {
        $receiver = $this->faker->name() . '|' . $this->faker->freeEmail;
        $this->model->setMailReceiver($receiver);
        $this->assertEquals($receiver, $this->model->getMailReceiver());
    }

    /**
     * @test
     */
    public function mailBodyCouldBeSet()
    {
        $mailBody = $this->faker->paragraph(10);
        $this->model->setMailBody($mailBody);
        $this->assertEquals($mailBody, $this->model->getMailBody());
    }

    /**
     * @test
     */
    public function mailReceiverCcCouldBeSet()
    {
        $receiver = $this->faker->name() . '|' . $this->faker->email . PHP_EOL;
        $receiver .= $this->faker->name() . '|' . $this->faker->email;
        $this->model->setMailReceiverCc($receiver);
        $this->assertEquals($receiver, $this->model->getMailReceiverCc());
    }

    /**
     * @test
     */
    public function mailReceiverBccCouldBeSet()
    {
        $receiver = $this->faker->name() . '|' . $this->faker->email . PHP_EOL;
        $receiver .= $this->faker->name() . '|' . $this->faker->email;
        $this->model->setMailReceiverBcc($receiver);
        $this->assertEquals($receiver, $this->model->getMailReceiverBcc());
    }

    /**
     * @test
     */
    public function mailSenderCouldBeSet()
    {
        $sender = $this->faker->name() . '|' . $this->faker->email;
        $this->model->setMailSender($sender);
        $this->assertEquals($sender, $this->model->getMailSender());
    }

    /**
     * @test
     */
    public function mailReturnPathCouldBeSet()
    {
        $returnPath = $this->faker->email;
        $this->model->setMailReturnPath($returnPath);
        $this->assertEquals($returnPath, $this->model->getMailReturnPath());
    }

    /**
     * @test
     */
    public function mailReplyToCouldBeSet()
    {
        $reply = $this->faker->name() . '|' . $this->faker->email;
        $this->model->setMailReplyTo($reply);
        $this->assertEquals($reply, $this->model->getMailReplyTo());
    }

    /**
     * @test
     */
    public function mailAttachmentCouldBeSet()
    {
        $attachment = new FileReference();
        $attachment->_setProperty('uid', 1);

        $attachmentStorage = new ObjectStorage();
        $attachmentStorage->attach($attachment);

        $this->model->setMailAttachment($attachmentStorage);
        $this->assertEquals($attachmentStorage, $this->model->getMailAttachment());
        $this->assertEquals(1, count($this->model->getMailAttachment()));
    }
}
