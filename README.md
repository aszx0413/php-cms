# php-cms

It should be fun.

## Usage

`~ php index.php [param]`

## Excel格式

#### 实体标识

- 每一个实体以一行**标题行**为开始，以**结尾空行**表示结束
- 判断`Bn`==`Table`表示开始
- 第1列为“实体处理标识”，当有`i`标识符时表示**ignored/忽略处理**

#### 标题行

- Bn 当内容为`Table`时表示实体开始标识
- Bn+1 Col 表示**字段名称**
- C 字段 表示**字段中文名称**。
    - 数据库建表语句的`comment`
    - 表单中的`label`提示
    - 列表中的表头属性
- D Type 表示**类型**
    - VARCHAR
    - INT
    - TINYINT
    
#### 公共属性

- id 自增唯一标识
    - `PRIMARY KEY`
    - `AUTO INCREMENT`
- add_time 入库时间
- update_time 更新时间
- status 状态
    - 1-正常
    - 0-无效
    - 9-未知/待审核
    
