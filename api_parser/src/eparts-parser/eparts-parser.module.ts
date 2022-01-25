import { Module } from '@nestjs/common';
import { EpartsParserController } from './eparts-parser.controller';
import { EpartsParserService } from './eparts-parser.service';

@Module({
  controllers: [EpartsParserController],
  providers: [EpartsParserService]
})
export class EpartsParserModule {}
