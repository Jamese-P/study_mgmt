set -e

if [ $# -eq 1 ]; then
    file_name=$1
elif [ $# -eq 2 ]; then
    file_name=$2
    if [ $1 = "-a" ]; then
        echo "Answer mode"
    else
        echo 引数エラー
        exit 1
    fi
else
    echo 引数エラー
    exit 1
fi

gsed '2a \\\answerfalse' ${file_name}.tex > out/${file_name}.tex
platex -output-directory=out -halt-on-error out/${file_name}.tex
dvipdfmx out/${file_name}.dvi

cp ${file_name}.pdf ../files

if [ $1 = "-a" ]; then
    gsed '2a \\\answertrue' ${file_name}.tex > out/${file_name}_answer.tex
    platex -output-directory=out -halt-on-error out/${file_name}_answer.tex
    dvipdfmx out/${file_name}_answer.dvi

    mv ${file_name}_answer.pdf ../files
fi

rm -rf out/*.aux
rm -rf out/*.dvi
rm -rf out/*.log
