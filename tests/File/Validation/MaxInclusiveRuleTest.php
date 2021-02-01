<?php

declare(strict_types=1);

namespace WsdlToPhp\PackageGenerator\Tests\File\Validation;

use InvalidArgumentException;

final class MaxInclusiveRuleTest extends AbstractRuleTest
{

    /**
     * The Percent
     * Meta informations extracted from the WSDL
     * - documentation: Fee percentage; if zero, assume use of the Amount attribute (Amount or Percent must be a zero value). | Used for percentage values.
     * - base: xs:decimal
     * - maxInclusive: 100.00
     * - minInclusive: 0.00
     */
    public function testSetPercentWithHigherFloatValueMustThrowAnException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value 100.01, the value must be numerically less than or equal to 100.00');

        $instance = self::getWhlTaxTypeInstance();

        $instance->setPercent(100.01);
    }

    /**
     * The Percent
     * Meta informations extracted from the WSDL
     * - documentation: Fee percentage; if zero, assume use of the Amount attribute (Amount or Percent must be a zero value). | Used for percentage values.
     * - base: xs:decimal
     * - maxInclusive: 100.00
     * - minInclusive: 0.00
     */
    public function testSetPercentWithSameFloatValueMustPass()
    {
        $instance = self::getWhlTaxTypeInstance();

        $this->assertSame($instance, $instance->setPercent(100.00));
    }

    /**
     * The Percent
     * Meta informations extracted from the WSDL
     * - documentation: Fee percentage; if zero, assume use of the Amount attribute (Amount or Percent must be a zero value). | Used for percentage values.
     * - base: xs:decimal
     * - maxInclusive: 100.00
     * - minInclusive: 0.00
     */
    public function testSetPercentWithSameIntValueMustPass()
    {
        $instance = self::getWhlTaxTypeInstance();

        $this->assertSame($instance, $instance->setPercent(100));
    }

    /**
     * The Percent
     * Meta informations extracted from the WSDL
     * - documentation: Fee percentage; if zero, assume use of the Amount attribute (Amount or Percent must be a zero value). | Used for percentage values.
     * - base: xs:decimal
     * - maxInclusive: 100.00
     * - minInclusive: 0.00
     */
    public function testSetPercentWithLowerIntValueMustPass()
    {
        $instance = self::getWhlTaxTypeInstance();

        $this->assertSame($instance, $instance->setPercent(99));
    }

    /**
     * The Percent
     * Meta informations extracted from the WSDL
     * - documentation: Fee percentage; if zero, assume use of the Amount attribute (Amount or Percent must be a zero value). | Used for percentage values.
     * - base: xs:decimal
     * - maxInclusive: 100.00
     * - minInclusive: 0.00
     */
    public function testSetPercentWithNullValueMustPass()
    {
        $instance = self::getWhlTaxTypeInstance();

        $this->assertSame($instance, $instance->setPercent(null));
    }

    public function testApplyRuleWithDateIntervalMustBeTrueWithLowerInterval()
    {
        $functionName = parent::createRuleFunction('WsdlToPhp\PackageGenerator\File\Validation\MaxInclusiveRule', 'P10675199DT2H49M5.4775807S');
        $this->assertTrue(call_user_func($functionName, 'P10675199DT2H49M4.4775807S'));
    }

    public function testApplyRuleWithDateIntervalMustBeTrueWithSameInterval()
    {
        $functionName = parent::createRuleFunction('WsdlToPhp\PackageGenerator\File\Validation\MaxInclusiveRule', $interval = 'P10675199DT2H49M5.4775807S');
        $this->assertTrue(call_user_func($functionName, $interval));
    }

    public function testApplyRuleWithDateIntervalMustBeFalseWthHigherInterval()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value \'P10675199DT2H49M6.4775807S\', the value must be chronologically less than or equal to P10675199DT2H49M5.4775807S');

        $functionName = parent::createRuleFunction('WsdlToPhp\PackageGenerator\File\Validation\MaxInclusiveRule', 'P10675199DT2H49M5.4775807S');
        $this->assertTrue(call_user_func($functionName, 'P10675199DT2H49M6.4775807S'));
    }
}
