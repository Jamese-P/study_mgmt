# 学習管理アプリ
## 概要
参考書を登録し、どの参考書を何日おきに何ページ学習するかを登録することで、今日やるべきページを一覧表示してくれ、そのページの学習が完了すると理解度やコメントなどを登録できる。

## 作成背景
塾講師として働いていて、宿題を大量に出すとなかなかやってこず、学習習慣が確立していない生徒が多くいた。そこで、毎日この教材をどれだけ勉強するなどの管理をしてくれるようなアプリケーションを作成しようと思った。

## 目的・ユースケース
生徒が自分の学習について管理し、学習記録を残すことが目的である。管理者の存在を作成していないのは生徒の自立力をできるだけ尊重し、育てたいからである。

## 使用技術
laravel, DB, html, css, tailwind, JavaScript, php

fullcalendar, sortable


## テスト用アカウント
- mail: test@example.com
- pass: password

## 機能
### 参考書登録機能
参考書の登録として以下の項目を登録する
- 参考書名
- 教科
- ページか単元か
- 開始ページまたは単元
- 終了ページまたは単元
- 一回の学習量
- 学習間隔
- 初回学習日

<img width="1439" alt="スクリーンショット 2023-09-16 14 35 32" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/93bca52c-f625-4c67-9f5d-3c34a6b20183">

情報を全て登録すると、終了予定日が自動的に計算され、保存ボタンの上に表示される。


### 学習ページ表示機能（トップページ）
その日に学習する参考書とそれを何単元（ページ）学習する必要があるのかを表示してくれる。また、明日学習する分についても表示される。それぞれでcompleteボタンとpassボタンが表示される。このボタンの機能については次章で説明する。
ただし、学習間隔が毎日の参考書については今日の分が終了した後に、completeまたはpassボタンが表示されるようになる。

期限切れの参考書（予定通りに学習が終わっていない）がある場合にはそれらのリストも表示され、期限切れか持ち越しのボタンがそれぞれ表示される。期限切れと持ち越しのそれぞれのボタンを押した後の機能は次々章で説明する。

<img width="1440" alt="スクリーンショット 2023-09-16 14 33 40" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/f3565c8c-f08b-4ee3-9930-81b8870c1054">


### complete機能とpass機能
トップページに表示される本日または明日に割り当てられている参考書のページまたは単元をcompleteまたはpassボタンが表示され、以下のような操作を行うことができる。期限切れの参考書の単元またはページについても同様に行える。
#### complete  
completeボタンを押すと、理解度やコメントを打ち込むページになり、その単元またはページの理解度とコメントを入力することができ、それらは学習履歴として表示される。これにより、あるページまたは単元の学習を完了させると本日やるべき単元数が1減少して次から表示されるようになる。completeの際に入力し、保存できる項目は以下
  - 理解度(完璧、50%、解き直しの3段階)
  - コメント(なくても良い)

#### pass  
パスとはこのアプリでは、参考書などのテキストにおいて学習する必要のない白紙ページや説明のページなどを指し、パスしたページや単元は学習した単元数やページ数には含まれない。



https://github.com/Jamese-P/study_mgmt/assets/115977529/e205e928-6be2-4ae1-be01-a71bf39c4f49



#### 個別の学習登録  
予定されていない単元またはページを学習した際にもその記録を残しておくことができる。教科を選択すると該当する参考書が選べるようになり、それ以外に以下を入力する。
  - 単元またはページ数
  - 理解度(完璧、50%、解き直しの3段階)
  - コメント(なくても良い)

<img width="1440" alt="スクリーンショット 2023-09-16 14 32 53" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/2b769e27-47bb-4599-abde-920aa589eb57">

### 期限切れ機能
参考書の予定単元数がその日に終わらなかった場合に、次の日になるとトップページにそれらの参考書の一覧が表示され以下二つのどちらかを選択する。
- 期限切れ  
  予定通りに終わらなかった残った単元を期限切れとして、トップページに表示されるようになり、次の学習日には予定通りに終わったものとしてそれ以降の単元が表示される。
- 持ち越し  
  次の学習日には残ったところから表示されるようになる。

以上の機能について例で説明する。参考書を一日3単元やると設定している場合に、ある日は単元6までと予定していたが、1単元しかできず次の日になってしまったことを想定する。
このとき、期限切れを選択すると次の予定日には単元7から学習するように表示され、期限切れの箇所に単元5,6が表示されるようになる。また、持ち越しを選択すると次の学習日には単元5から学習するように表示される。

### 参考書の情報表示
#### 一覧表示  
参考書一覧のタブには、学習中の参考書と学習済みの参考書がわけて表示される。また、学習済みの参考書については以下で説明するような再学習するためのボタンが表示されている。また、一覧表示画面で表示される内容は以下
  - 参考書名
  - 教科
  - 進捗率
  - 学習間隔と1日の学習量
  - 終了ページまたは単元
  - 終了予定日

<img width="1440" alt="スクリーンショット 2023-09-16 14 32 16" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/8d83ce46-9feb-4893-ade0-6c03dd20ce3f">


#### 詳細表示  
一覧表示の参考書名にあるリンクをクリックするとその参考書の詳細表示となる。一覧表示で表示された内容に追加して、その参考書の学習履歴の一覧が表示される。editボタンをおし編集画面に行くと削除ボタンがあり、参考書を削除することができる。

<img width="1440" alt="スクリーンショット 2023-09-16 14 24 23" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/baa4182d-80f0-4717-a4b8-ab447ea06351">


### 再学習機能
参考書の一覧表示の再学習ボタンを押すと以下の画面に移動する。
ユーザーは理解度と初回学習日などを指定すると、その理解度以下のページまたは単元が次回学習日から勉強対象としてトップページに表示されるようになる。

<img width="1435" alt="スクリーンショット 2023-09-16 14 37 53" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/47d31def-8cbd-425f-be8d-c5f710ce09f3">



### 全学習履歴表示機能
全ての参考書の学習履歴が全て表示される。このとき学習日の新しい順に並んでいる。上部のチェックボックスによって表示する教科を絞ることができる。

以下のコラム名をクリックでそれぞれの項目でソートすることができる。
- 教科
- 参考書名
- 学習日
- 理解度



https://github.com/Jamese-P/study_mgmt/assets/115977529/c9d65e02-8281-49da-829a-7b6dfb930292



### カレンダー機能
カレンダー機能には二つの大きな機能がある。
- 個人の予定登録  
カレンダー上の日付をクリックするか左上の``+``によって新たな予定を登録することができる。ドラッグによって予定日の変更も可能である。
- 参考書の終了日の表示  
参考書の終了日または終了予定日が自動的に表示される。

<img width="1440" alt="スクリーンショット 2023-09-16 14 32 26" src="https://github.com/Jamese-P/study_mgmt/assets/115977529/fae24cf6-f294-426c-b3ab-40db14be3459">


