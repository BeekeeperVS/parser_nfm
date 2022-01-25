import {Module} from '@nestjs/common';
import {AppController} from './app.controller';
import {AppService} from './app.service';
import {EpartsParserModule} from './eparts-parser/eparts-parser.module';
import {ConfigModule} from "@nestjs/config";

@Module({
    imports: [
        ConfigModule.forRoot(),
        EpartsParserModule
    ],
    controllers: [AppController],
    providers: [AppService],
})
export class AppModule {
}
