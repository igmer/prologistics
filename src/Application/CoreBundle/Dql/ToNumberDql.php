<?php
/*
 *  TO_NUMBER
 *      Función que convierte un string a un número.
 *
 *  DBMS Soportados | Documentación
 *  ----------------+-----------------------------------------------------------
 *      PostgreSql  |   http://www.postgresql.org/docs/8.3/static/functions-formatting.html
 *      Oracle      |   http://docs.oracle.com/cd/B19306_01/server.102/b14200/functions191.htm
 *
 *  ToNumberFunction ::= "TO_NUMBER" "(" ArithmeticExpression "," StringPrimary ")"
 */
namespace Application\CoreBundle\Dql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class DqlToNumber extends FunctionNode {

    public $field;
    public $pattern;

    public function parse(\Doctrine\ORM\Query\Parser $parser) {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->pattern = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {
        return 'TO_NUMBER(' .
            $this->field->dispatch($sqlWalker) .','.
            $this->pattern->dispatch($sqlWalker).
        ')';
    }
}
