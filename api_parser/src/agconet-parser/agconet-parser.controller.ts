import {Body, Controller, Post, Res} from '@nestjs/common';
import {Response} from "express";
import {AgconetParserService} from "./agconet-parser.service";
import {ConfigService} from "@nestjs/config";

const puppeteer = require("puppeteer-extra");

@Controller('agconet-parser')
export class AgconetParserController {

    constructor(private readonly agconetParserService: AgconetParserService) {
    }

    @Post('login')
    async login(@Body() dto, @Res() res: Response) {
        try {
            let cookies = [];

            let launchArgs = [
                '--disable-gpu',
                '--disable-dev-shm-usage',
                '--no-sandbox',
                '--disable-setuid-sandbox'
            ];

            let browser = await puppeteer.launch({
                headless: true,
                slowMo: 10,
                ignoreHTTPSErrors: true,
                devtools: false,
                args: launchArgs
            });

            let context = await browser.createIncognitoBrowserContext();
            let page = await context.newPage();

            await page.goto(process.env.AGCONET_LOGIN_URL);
            await page.evaluate(async (login, password) => {
                let loginElement = document.querySelector('#login input[name="iusername"]');
                let passwordElement = document.querySelector('#login input[name="ipassword"]');
                // @ts-ignore
                loginElement.value = login;
                loginElement.dispatchEvent(new Event("change"));
                // @ts-ignore
                passwordElement.value = password;
                passwordElement.dispatchEvent(new Event("change"));

            }, process.env.AGCONET_LOGIN, process.env.AGCONET_PASSWORD);
            await sleep(5000);
            await page.waitForTimeout(2000);
            await page.click("button#button1");
            await sleep(5000);
            cookies = await page.cookies();
            await page.close();
            await context.close();
            await browser.close();

            res.send({status: true, data: {cookies: cookies}});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}