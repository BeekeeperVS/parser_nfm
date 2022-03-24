import {Body, Controller, Post, Res} from '@nestjs/common';
import {Response} from "express";
import {AgconetParserService} from "./agconet-parser.service";
import {parserConfig} from "./config/ParserConfig";
import {Login} from "./steps-parser/Login";
import {LoginDto} from "./dto/LoginDto";
import {Brands} from "./steps-parser/Brands";
import {BrandsDto} from "./dto/BrandsDto";
import {BrandItemDto} from "./dto/BrandItemDto";
import {BrandItem} from "./steps-parser/BrandItem";
import {CategoryDto} from "./dto/CategoryDto";
import {CatalogPats} from "./steps-parser/CatalogPats";
import {ModelGroups} from "./steps-parser/ModelGroups";
import {Models} from "./steps-parser/Models";
import {ModelSchemes} from "./steps-parser/ModelSchems";
import {ModelSchemesDto} from "./dto/ModelSchemesDto";
import {Schemes} from "./steps-parser/Schemes";
import {SchemesDto} from "./dto/SchemesDto";
import {SchemeDetailDto} from "./dto/SchemeDetailDto";
import {SchemeDetail} from "./steps-parser/SchemeDetail";

@Controller('agconet-parser')
export class AgconetParserController {

    constructor(private readonly agconetParserService: AgconetParserService) {
    }

    @Post('login')
    async login(@Body() dto: LoginDto, @Res() res: Response) {
        try {
            let stepModel = new Login(parserConfig());
            let responseData = await stepModel.get(dto)
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('brands')
    async brands(@Body() dto: BrandsDto, @Res() res: Response) {
        try {
            let stepModel = new Brands(parserConfig());
            let responseData = await stepModel.get(dto)
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('brand-item')
    async brandItem(@Body() dto: BrandItemDto, @Res() res: Response) {
        try {
            let stepModel = new BrandItem(parserConfig());
            let responseData = await stepModel.get(dto)
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('catalog-pats')
    async catalogPats(@Body() dto: CategoryDto, @Res() res: Response) {
        try {
            let stepModel = new CatalogPats(parserConfig());
            let responseData = await stepModel.get(dto)
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('model-groups')
    async modelGroups(@Body() dto: CategoryDto, @Res() res: Response) {
        try {
            let stepModel = new ModelGroups(parserConfig());
            let responseData = await stepModel.get(dto)
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('models')
    async models(@Body() dto: CategoryDto, @Res() res: Response) {
        try {
            let stepModel = new Models(parserConfig());
            let responseData = await stepModel.get(dto)
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('model-schemes')
    async modelSchemes(@Body() dto: ModelSchemesDto, @Res() res: Response) {
        try {
            let stepModel = new ModelSchemes(parserConfig());
            let responseData = await stepModel.get(dto);
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('schemes')
    async schemes(@Body() dto: SchemesDto, @Res() res: Response) {
        try {
            let stepModel = new Schemes(parserConfig());
            let responseData = await stepModel.get(dto);
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }

    @Post('scheme-detail')
    async schemeDetail(@Body() dto: SchemeDetailDto, @Res() res: Response) {
        try {
            let stepModel = new SchemeDetail(parserConfig());
            let responseData = await stepModel.get(dto);
            res.send({status: true, data: responseData});
        } catch (exception) {
            res.send({status: false, error: exception.message});
        }
        return true;
    }
    
}