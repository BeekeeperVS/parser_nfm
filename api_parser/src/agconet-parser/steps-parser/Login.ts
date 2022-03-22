import {ParserHeaderConfigInterface} from "../config/ParserConfig"
import {Axios} from "axios";
import {response} from "express";
import puppeteer from "puppeteer-extra";
import {LoginDto} from "../dto/LoginDto";

export interface LoginItemInterface {
    cookies: any,
    bearerToken: string
}

interface TemplateInterface {
    get(dto: LoginDto): LoginItemInterface;
}

export class Login implements TemplateInterface {

    static apiMethod = '/brands';

    constructor(private readonly parserConfig: ParserHeaderConfigInterface) {
    }

    // @ts-ignore
    async get(dto: LoginDto): LoginItemInterface {
        let cookies = [];

        let launchArgs = [
            '--disable-gpu',
            '--disable-dev-shm-usage',
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--start-maximized'
        ];

        let browser = await puppeteer.launch({
            headless: true,
            slowMo: 10,
            ignoreHTTPSErrors: true,
            devtools: false,
            args: launchArgs
        });

        let page = await browser.newPage();
        await page.setViewport({width: 1366, height: 768});
        await page.goto(this.parserConfig.loginUrl);
        await page.evaluate(async (login, password) => {
            let loginElement = document.querySelector('#login input[name="iusername"]');
            let passwordElement = document.querySelector('#login input[name="ipassword"]');
            // @ts-ignore
            loginElement.value = login;
            loginElement.dispatchEvent(new Event("change"));
            // @ts-ignore
            passwordElement.value = password;
            passwordElement.dispatchEvent(new Event("change"));

        }, this.parserConfig.login, this.parserConfig.password);

        await page.click("button#button1");
        await sleep(5000);

        /*------------------New Tab---------------------*/
        const newPagePromise = new Promise(x => page.once('popup', x));
        await page.goto(this.parserConfig.catalogUrl);
        const newPage = await newPagePromise;
        await sleep(25000);
        // @ts-ignore
        cookies = await newPage.cookies();
        // @ts-ignore
        const localStorageData = await newPage.evaluate(() => {
            let json = {};
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                json[key] = localStorage.getItem(key);
            }
            return json;
        });

        await page.close();
        // @ts-ignore
        await newPage.close();
        await browser.close();

        let response = {cookies: cookies, bearerToken: localStorageData.aic_token}

        return response;
    }
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}