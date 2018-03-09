<?php
/*
 *  TO_CHAR
 *      Evalúa los argumentos en orden y devuelve el valor actual de la primera
 *      expresión que inicialmente no se evalúa como NULL.
 *
 *  DBMS Soportados | Documentación
 *  ----------------+-----------------------------------------------------------
 *      PostgreSql  |   http://www.postgresql.org/docs/9.1/static/functions-conditional.html
 *
 *  ToCharFunction ::= "TO_CHAR" "(" ArithmeticExpression "," StringPrimary ")"
 */
namespace Application\CoreBundle\Dql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class ToCharDql extends FunctionNode {

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
        return 'TO_CHAR(' .
            $this->field->dispatch($sqlWalker) .','.
            $this->pattern->dispatch($sqlWalker).
        ')';
    }
}
