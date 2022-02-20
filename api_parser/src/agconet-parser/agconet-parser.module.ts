import { Module } from '@nestjs/common';
import { AgconetParserController } from './agconet-parser.controller';
import { AgconetParserService } from './agconet-parser.service';

@Module({
  controllers: [AgconetParserController],
  providers: [AgconetParserService]
})
export class AgconetParserModule {}
