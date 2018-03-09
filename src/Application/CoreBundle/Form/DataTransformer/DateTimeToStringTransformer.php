<?php
// src/Application/CoreBundle/Form/DataTransformer/DateTimeToStringTransformer.php
namespace Application\CoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\TaskBundle\Entity\Issue;

class DateTimeToStringTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $format;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $format = 'd/m/Y h:i:s A')
    {
        $this->om = $om;
        $this->format = $format;
    }

    /**
     * Transforms an DateTime (dateTime) to a string with format (dateTiemString).
     *
     * @param  \DateTime|null $dateTime
     * @return string
     */
    public function transform($dateTime)
    {
        if (null === $dateTime) {
            return "";
        }

        return $dateTime->format($this->format);
    }

    /**
     * Transforms a string (dateTiemString) to an DateTime (dateTime).
     *
     * @param  string $dateTimeString
     *
     * @return \DateTime|null
     *
     * @throws TransformationFailedException if string (dateTiemString) can't be converted in a DateTiem (dateTime).
     */
    public function reverseTransform($dateTimeString)
    {
        if (!$dateTimeString) {
            return null;
        }

        try {
            $dateTime = \DateTime::createFromFormat($this->format, $dateTimeString);
        } catch(\Exception $e) {
            throw new TransformationFailedException(sprintf(
                'An issue to try transformer string "%s" into DateTiem with Format %s!',
                $dateTimeString, $this->format
            ));
        }

        return $dateTime;
    }
}
