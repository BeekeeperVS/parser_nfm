import {Body, Controller, Post, Res} from '@nestjs/common';
import {Response} from "express";
import {BrandParserDto} from "./dto/BrandParserDto";
import {Brands} from "./steps-parser/Brands";
import {parserConfig} from "./config/ParserConfig"
import {ProductTypes} from "./steps-parser/ProductTypes";
import {ProductLines} from "./steps-parser/ProductLines";
import {ProductLineParserDto} from "./dto/ProductLineParserDto";
import {ProductTypeParserDto} from "./dto/ProductTypeParserDto";

@Controller('eparts-parser')
export class EpartsParserController {

    @Post('test')
    async test(@Body() brandParserDto: BrandParserDto, @Res() res: Response) {
            let brands = new Brands(parserConfig());
            let brandsList = await brands.get();
            res.send({status: true, brands: brandsList});

        return true;
    }

    @Post('test2')
    async test2(@Body() productTypeParserDto: ProductTypeParserDto, @Res() res: Response) {
        let productTypes = new ProductTypes(parserConfig());
        let productTypesList = await productTypes.get();
        res.send({status: true, productTypes: productTypesList});

        return true;
    }

    @Post('test3')
    async test3(@Body() productLinesParserDto: ProductLineParserDto, @Res() res: Response) {
        let productTypes = new ProductLines(parserConfig());
        let productTypesList = await productTypes.get(productLinesParserDto.productTypeId);
        res.send({status: true, productLines: productTypesList});
        return true;
    }

}
