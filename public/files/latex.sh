set -e

if [ $# != 1 ]; then
    echo 引数エラー
    exit 1
fi

# sed '2d' $1.tex > out/${1}_answer.tex


gsed '2a \\\answerfalse' $1.tex > out/${1}.tex
platex -output-directory=out -halt-on-error out/${1}.tex
dvipdfmx out/$1.dvi

gsed '2a \\\answertrue' $1.tex > out/${1}_answer.tex
platex -output-directory=out -halt-on-error out/${1}_answer.tex
dvipdfmx out/${1}_answer.dvi

rm -rf out/*.aux
rm -rf out/*.dvi
rm -rf out/*.log
