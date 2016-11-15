<?php

namespace Pantheon\Terminus\UnitTests\Commands\Branch;

use Pantheon\Terminus\Commands\Branch\ListCommand;
use Pantheon\Terminus\UnitTests\Commands\CommandTestCase;
use Terminus\Collections\Branches;
use Terminus\Models\Branch;

class ListCommandTest extends CommandTestCase
{
    public function testListBranches()
    {
        $branches_info = [
            ['id' => 'master', 'sha' => 'xxx'],
            ['id' => 'another', 'sha' => 'yyy'],
        ];

        $branches = [];
        foreach ($branches_info as $branch_info) {
            $branch = $this->getMockBuilder(Branch::class)
                ->disableOriginalConstructor()
                ->getMock();
            $branch->expects($this->once())
                ->method('serialize')
                ->willReturn($branch_info);
            $branches[] = $branch;
        }
        $this->site->branches = $this->getMockBuilder(Branches::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->site->branches->expects($this->once())
            ->method('all')
            ->willReturn($branches);

        $command = new ListCommand();
        $command->setSites($this->sites);
        $out = $command->listBranches('my-site');
        $this->assertEquals($branches_info, $out->getArrayCopy());
    }
}