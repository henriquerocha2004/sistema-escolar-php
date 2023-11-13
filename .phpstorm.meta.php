<?php

namespace PHPSTORM_META;

override(\Mockery::mock(0), map(["" => "@&\Mockery\MockInterface"]));
override(\Mockery::spy(0), map(["" => "@&\Mockery\MockInterface"]));
override(\Mockery::namedMock(0), map(["" => "@&\Mockery\MockInterface"]));
override(\Mockery::instanceMock(0), map(["" => "@&\Mockery\MockInterface"]));
override(\mock(0), map(["" => "@&\Mockery\MockInterface"]));
override(\spy(0), map(["" => "@&\Mockery\MockInterface"]));
override(\namedMock(0), map(["" => "@&\Mockery\MockInterface"]));

override(
    \PHPUnit\Framework\TestCase::createMock(0),
    map(["" => "@&\PHPUnit\Framework\MockObject\MockObject"])
);
override(
    \PHPUnit\Framework\TestCase::createStub(0),
    map(["" => "@&\PHPUnit\Framework\MockObject\Stub"])
);
override(
    \PHPUnit\Framework\TestCase::createConfiguredMock(0),
    map(["" => "@&\PHPUnit\Framework\MockObject\MockObject"])
);
override(
    \PHPUnit\Framework\TestCase::createPartialMock(0),
    map(["" => "@&\PHPUnit\Framework\MockObject\MockObject"])
);
override(
    \PHPUnit\Framework\TestCase::createTestProxy(0),
    map(["" => "@&\PHPUnit\Framework\MockObject\MockObject"])
);
override(
    \PHPUnit\Framework\TestCase::getMockForAbstractClass(0),
    map(["" => "@&\PHPUnit\Framework\MockObject\MockObject"])
);
