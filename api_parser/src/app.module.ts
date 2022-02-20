import {Module} from '@nestjs/common';
import {AppController} from './app.controller';
import {AppService} from './app.service';
import {EpartsParserModule} from './eparts-parser/eparts-parser.module';
import {ConfigModule} from "@nestjs/config";
import { AgconetParserModule } from './agconet-parser/agconet-parser.module';

@Module({
    imports: [
        ConfigModule.forRoot(),
        EpartsParserModule,
        AgconetParserModule
    ],
    controllers: [AppController],
    providers: [AppService],
})
export class AppModule {
}
